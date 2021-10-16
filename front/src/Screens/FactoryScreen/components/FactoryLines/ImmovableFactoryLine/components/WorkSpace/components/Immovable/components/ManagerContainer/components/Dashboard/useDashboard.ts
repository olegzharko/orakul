import { useSelector, useDispatch } from 'react-redux';
import { useHistory, useParams } from 'react-router-dom';
import { useEffect, useCallback, useState, useMemo } from 'react';

import { fetchImmovables, setImmovables } from '../../../../../../../../../../../../../store/immovables/actions';
import { State } from '../../../../../../../../../../../../../store/types';
import { UserTypes } from '../../../../../../../../../../../../../types';
import { setModalInfo } from '../../../../../../../../../../../../../store/main/actions';
import deleteImmovable from '../../../../../../../../../../../../../services/generator/Immovable/deleteImmovable';
import routes from '../../../../../../../../../../../../../routes';

export const useDashboard = () => {
  const { lineItemId } = useParams<{ lineItemId: string }>();
  const dispatch = useDispatch();
  const history = useHistory();

  const { token } = useSelector((state: State) => state.main.user);
  const { immovables, isLoading } = useSelector((state: State) => state.immovables);

  const [showModal, setShowModal] = useState<boolean>(false);
  const [immovableNeedToRemove, setImmovableNeedToRemove] = useState<any>();

  const clientRemove = useCallback((personId: string) => {
    (async () => {
      if (token) {
        const { success, message, data } = await deleteImmovable(token, lineItemId, personId);

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
  }, [token, lineItemId, dispatch]);

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

  const onCardClick = useCallback((link: string) => {
    history.push(link);
  }, [history]);

  const mappedImmovables = useMemo(() => immovables.map((immovable) => ({
    ...immovable,
    onRemove: () => onModalShow(immovable.id.toString()),
    onClick: () => onCardClick(
      routes.factory.lines.immovable.sections.immovables.immovableView.linkTo(
        lineItemId, immovable.id
      )
    ),
  })), [immovables, lineItemId, onCardClick, onModalShow]);

  useEffect(() => {
    dispatch(fetchImmovables(lineItemId, UserTypes.MANAGER));

    return () => { dispatch(setImmovables([])); };
  }, [dispatch, lineItemId]);

  return {
    lineItemId,
    isLoading,
    mappedImmovables,
    showModal,
    onModalCancel,
    onModalConfirm,
    onModalShow,
  };
};
