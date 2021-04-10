import { useSelector, useDispatch } from 'react-redux';
import { useParams } from 'react-router-dom';
import { useEffect, useCallback, useState } from 'react';
import { State } from '../../../../../../../../../../store/types';
import getSideNotaries from '../../../../../../../../../../services/generator/SideNotary/getSideNotaries';

type SideNotary = {
  id: number,
  title: string,
  list: string[]
}

export const useDashboard = () => {
  const { id } = useParams<{ id: string }>();
  const { token } = useSelector((state: State) => state.main.user);

  const [notaries, setNotaries] = useState<SideNotary[]>([]);
  const [isLoading, setIsLoading] = useState<boolean>();

  const [showModal, setShowModal] = useState<boolean>(false);
  const [notaryNeedToRemove, setNotaryNeedToRemove] = useState<any>();

  const clientRemove = useCallback((personId: string) => {
    // (async () => {
    //   if (token) {
    //     const { success, message, data } = await reqClientName(token, id, personId, 'DELETE');

    //     if (success) {
    //       dispatch(setClients(data));
    //       dispatch(
    //         setModalInfo({
    //           open: true,
    //           success,
    //           message,
    //         })
    //       );
    //     }
    //   }
    // })();
  }, [token, notaryNeedToRemove]);

  const onModalShow = useCallback((personId: string) => {
    setShowModal(true);
    setNotaryNeedToRemove(personId);
  }, []);

  const onModalConfirm = useCallback(() => {
    setShowModal(false);
    clientRemove(notaryNeedToRemove);
  }, [notaryNeedToRemove]);

  const onModalCancel = useCallback(() => {
    setShowModal(false);
    setNotaryNeedToRemove(undefined);
  }, []);

  useEffect(() => {
    if (token) {
      // get SIDE_NOTARIES
      (async () => {
        setIsLoading(true);
        const res = await getSideNotaries(token, id);

        if (res.success) {
          setNotaries(res.data.notary);
        }
        setIsLoading(false);
      })();
    }
  }, [token, id]);

  return {
    id,
    isLoading,
    notaries,
    showModal,
    onModalCancel,
    onModalConfirm,
    onModalShow,
  };
};
