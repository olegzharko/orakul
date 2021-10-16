import { useSelector, useDispatch } from 'react-redux';
import { useHistory, useParams } from 'react-router-dom';
import { useEffect, useCallback, useState, useMemo } from 'react';

import { UserTypes } from '../../../../../../../../../../../../../types';
import { State } from '../../../../../../../../../../../../../store/types';
import { fetchClients, setClients } from '../../../../../../../../../../../../../store/clients/actions';
import { setModalInfo } from '../../../../../../../../../../../../../store/main/actions';
import deleteManagerClient from '../../../../../../../../../../../../../services/manager/Clients/deleteManagerClient';
import routes from '../../../../../../../../../../../../../routes';

export const useDashboard = () => {
  const { lineItemId } = useParams<{ lineItemId: string }>();
  const dispatch = useDispatch();
  const history = useHistory();

  const { token } = useSelector((state: State) => state.main.user);
  const { clients, isLoading } = useSelector((state: State) => state.clients);

  const [showModal, setShowModal] = useState<boolean>(false);
  const [personNeedToRemove, setPersonNeedToRemove] = useState<any>();

  const clientRemove = useCallback((personId: string) => {
    (async () => {
      if (token) {
        const { success, message, data } = await deleteManagerClient(token, personId, lineItemId);

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
  }, [token, lineItemId, dispatch]);

  const onModalShow = useCallback((personId: string) => {
    setShowModal(true);
    setPersonNeedToRemove(personId);
  }, []);

  const onModalConfirm = useCallback(() => {
    setShowModal(false);
    clientRemove(personNeedToRemove);
  }, [clientRemove, personNeedToRemove]);

  const onModalCancel = useCallback(() => {
    setShowModal(false);
    setPersonNeedToRemove(undefined);
  }, []);

  const onCardClick = useCallback((link: string) => {
    history.push(link);
  }, [history]);

  const mappedClients = useMemo(() => clients.map((client) => ({
    ...client,
    onRemove: () => onModalShow(client.id.toString()),
    onClick: () => onCardClick(routes.factory.lines.immovable.sections.clients.clientView.linkTo(
      lineItemId, client.id
    ))
  })), [clients, lineItemId, onCardClick, onModalShow]);

  useEffect(() => {
    dispatch(fetchClients(lineItemId, UserTypes.MANAGER));

    return () => { dispatch(setClients([])); };
  }, [dispatch, lineItemId]);

  return {
    lineItemId,
    isLoading,
    mappedClients,
    showModal,
    onModalCancel,
    onModalConfirm,
  };
};
