import { useSelector, useDispatch } from 'react-redux';
import { useHistory, useParams } from 'react-router-dom';
import { useCallback, useEffect } from 'react';

import { UserTypes } from '../../../../../../../../../../../../types';
import { State } from '../../../../../../../../../../../../store/types';
import { fetchClients } from '../../../../../../../../../../../../store/clients/actions';

export const useClientsDashboard = () => {
  const { id } = useParams<{ id: string }>();
  const dispatch = useDispatch();
  const history = useHistory();

  const { clients, isLoading } = useSelector((state: State) => state.clients);

  // !can use remove client here in future

  // const [showModal, setShowModal] = useState<boolean>(false);
  // const [personNeedToRemove, setPersonNeedToRemove] = useState<any>();

  // const clientRemove = useCallback((personId: string) => {
  //   (async () => {
  //     if (token) {
  //       const { success, message, data } = await reqClientName(token, id, personId, 'DELETE');

  //       if (success) {
  //         dispatch(setClients(data));
  //         dispatch(
  //           setModalInfo({
  //             open: true,
  //             success,
  //             message,
  //           })
  //         );
  //       }
  //     }
  //   })();
  // }, [token, personNeedToRemove]);

  // const onModalShow = useCallback((personId: string) => {
  //   setShowModal(true);
  //   setPersonNeedToRemove(personId);
  // }, []);

  // const onModalConfirm = useCallback(() => {
  //   setShowModal(false);
  //   clientRemove(personNeedToRemove);
  // }, [personNeedToRemove]);

  // const onModalCancel = useCallback(() => {
  //   setShowModal(false);
  //   setPersonNeedToRemove(undefined);
  // }, []);

  const onCardClick = useCallback((link: string) => {
    history.push(link);
  }, [history]);

  useEffect(() => {
    dispatch(fetchClients(id, UserTypes.GENERATOR));
  }, [dispatch, id]);

  return {
    id,
    isLoading,
    clients,
    onCardClick,
    // showModal,
    // onModalCancel,
    // onModalConfirm,
    // onModalShow,
  };
};
