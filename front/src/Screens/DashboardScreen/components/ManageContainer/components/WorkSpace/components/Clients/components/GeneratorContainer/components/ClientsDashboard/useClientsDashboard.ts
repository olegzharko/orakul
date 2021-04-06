import { useSelector, useDispatch } from 'react-redux';
import { useParams } from 'react-router-dom';
import { useEffect, useCallback, useState } from 'react';
import { State } from '../../../../../../../../../../../../store/types';
import { fetchClients, setClients } from '../../../../../../../../../../../../store/clients/actions';
import reqClientName from '../../../../../../../../../../../../services/generator/Client/reqClientName';
import { setModalInfo } from '../../../../../../../../../../../../store/main/actions';

export const useClientsDashboard = () => {
  const { id } = useParams<{ id: string }>();
  const dispatch = useDispatch();

  const { token } = useSelector((state: State) => state.main.user);
  const { clients, isLoading } = useSelector((state: State) => state.clients);

  const [showModal, setShowModal] = useState<boolean>(false);
  const [personNeedToRemove, setPersonNeedToRemove] = useState<any>();

  const clientRemove = useCallback((personId: string) => {
    (async () => {
      if (token) {
        const { success, message, data } = await reqClientName(token, personId, 'DELETE');

        if (success) {
          dispatch(setClients(data));
          dispatch(
            setModalInfo({
              open: true,
              success,
              message,
            })
          );
        }
      }
    })();
  }, [token, personNeedToRemove]);

  const onModalShow = useCallback((personId: string) => {
    setShowModal(true);
    setPersonNeedToRemove(personId);
  }, []);

  const onModalConfirm = useCallback(() => {
    setShowModal(false);
    clientRemove(personNeedToRemove);
  }, [personNeedToRemove]);

  const onModalCancel = useCallback(() => {
    setShowModal(false);
    setPersonNeedToRemove(undefined);
  }, []);

  useEffect(() => {
    dispatch(fetchClients(id));
  }, [id]);

  return {
    id,
    isLoading,
    clients,
    showModal,
    onModalCancel,
    onModalConfirm,
    onModalShow,
  };
};
