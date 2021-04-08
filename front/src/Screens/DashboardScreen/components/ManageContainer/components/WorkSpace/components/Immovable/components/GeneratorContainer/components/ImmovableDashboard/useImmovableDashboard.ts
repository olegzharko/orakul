import { useSelector, useDispatch } from 'react-redux';
import { useParams } from 'react-router-dom';
import { useEffect, useCallback, useState } from 'react';
import { fetchImmovables } from '../../../../../../../../../../../../store/immovables/actions';
import { State } from '../../../../../../../../../../../../store/types';
import { setModalInfo } from '../../../../../../../../../../../../store/main/actions';

export const useImmovableDashboard = () => {
  const { id } = useParams<{ id: string }>();
  const dispatch = useDispatch();

  const { token } = useSelector((state: State) => state.main.user);
  const { immovables, isLoading } = useSelector((state: State) => state.immovables);

  const [showModal, setShowModal] = useState<boolean>(false);
  const [immovableNeedToRemove, setImmovableNeedToRemove] = useState<any>();

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
  }, [token, immovableNeedToRemove]);

  const onModalShow = useCallback((personId: string) => {
    setShowModal(true);
    setImmovableNeedToRemove(personId);
  }, []);

  const onModalConfirm = useCallback(() => {
    setShowModal(false);
    clientRemove(immovableNeedToRemove);
  }, [immovableNeedToRemove]);

  const onModalCancel = useCallback(() => {
    setShowModal(false);
    setImmovableNeedToRemove(undefined);
  }, []);

  useEffect(() => {
    dispatch(fetchImmovables(id));
  }, [id]);

  return {
    id,
    isLoading,
    immovables,
    showModal,
    onModalCancel,
    onModalConfirm,
    onModalShow,
  };
};
