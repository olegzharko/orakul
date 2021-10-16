import { useSelector, useDispatch } from 'react-redux';
import { useHistory, useParams } from 'react-router-dom';
import { useCallback, useEffect } from 'react';

import { UserTypes } from '../../../../../../../../../../../../../types';
import { fetchImmovables, setImmovables } from '../../../../../../../../../../../../../store/immovables/actions';
import { State } from '../../../../../../../../../../../../../store/types';

export const useDashboard = () => {
  const { lineItemId } = useParams<{ lineItemId: string }>();
  const dispatch = useDispatch();
  const history = useHistory();

  const { immovables, isLoading } = useSelector((state: State) => state.immovables);

  const onCardClick = useCallback((link: string) => {
    history.push(link);
  }, [history]);

  useEffect(() => {
    dispatch(fetchImmovables(lineItemId, UserTypes.GENERATOR));

    return () => { dispatch(setImmovables([])); };
  }, [dispatch, lineItemId]);

  return {
    lineItemId,
    isLoading,
    immovables,
    onCardClick,
  };
};
