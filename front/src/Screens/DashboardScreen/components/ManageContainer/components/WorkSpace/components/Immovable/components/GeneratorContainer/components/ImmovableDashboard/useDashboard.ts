import { useSelector, useDispatch } from 'react-redux';
import { useHistory, useParams } from 'react-router-dom';
import { useCallback, useEffect } from 'react';

import { UserTypes } from '../../../../../../../../../../../../types';
import { fetchImmovables, setImmovables } from '../../../../../../../../../../../../store/immovables/actions';
import { State } from '../../../../../../../../../../../../store/types';

export const useDashboard = () => {
  const { id } = useParams<{ id: string }>();
  const dispatch = useDispatch();
  const history = useHistory();

  const { immovables, isLoading } = useSelector((state: State) => state.immovables);

  const onCardClick = useCallback((link: string) => {
    history.push(link);
  }, [history]);

  useEffect(() => {
    dispatch(fetchImmovables(id, UserTypes.GENERATOR));

    return () => { dispatch(setImmovables([])); };
  }, [dispatch, id]);

  return {
    id,
    isLoading,
    immovables,
    onCardClick,
  };
};
