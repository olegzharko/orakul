import { useSelector, useDispatch } from 'react-redux';
import { useParams } from 'react-router-dom';
import { useEffect, useCallback, useState } from 'react';
import { fetchImmovables, setImmovables } from '../../../../../../../../../../../../store/immovables/actions';
import { State } from '../../../../../../../../../../../../store/types';
import { UserTypes } from '../../../../../../../../../../../../types';
import { setModalInfo } from '../../../../../../../../../../../../store/main/actions';
import deleteImmovable from '../../../../../../../../../../../../services/generator/Immovable/deleteImmovable';

export const useDashboard = () => {
  const { id } = useParams<{ id: string }>();
  const dispatch = useDispatch();

  const { token } = useSelector((state: State) => state.main.user);
  const { immovables, isLoading } = useSelector((state: State) => state.immovables);

  const [showModal, setShowModal] = useState<boolean>(false);
  const [immovableNeedToRemove, setImmovableNeedToRemove] = useState<any>();

  const clientRemove = useCallback((personId: string) => {
    (async () => {
      if (token) {
        const { success, message, data } = await deleteImmovable(token, id, personId);

        if (success) {
          dispatch(setImmovables(data));
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
  }, [token, id, dispatch]);

  const onModalShow = useCallback((personId: string) => {
    setShowModal(true);
    setImmovableNeedToRemove(personId);
  }, []);

  const onModalConfirm = useCallback(() => {
    setShowModal(false);
    clientRemove(immovableNeedToRemove);
  }, [immovableNeedToRemove, clientRemove]);

  const onModalCancel = useCallback(() => {
    setShowModal(false);
    setImmovableNeedToRemove(undefined);
  }, []);

  useEffect(() => {
    dispatch(fetchImmovables(id, UserTypes.MANAGER));

    return () => { dispatch(setImmovables([])); };
  }, [dispatch, id]);

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
