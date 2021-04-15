import { useSelector, useDispatch } from 'react-redux';
import { useParams } from 'react-router-dom';
import { useEffect } from 'react';
import { UserTypes } from '../../../../../../../../../../../../types';
import { fetchImmovables, setImmovables } from '../../../../../../../../../../../../store/immovables/actions';
import { State } from '../../../../../../../../../../../../store/types';

export const useDashboard = () => {
  const { id } = useParams<{ id: string }>();
  const dispatch = useDispatch();

  const { immovables, isLoading } = useSelector((state: State) => state.immovables);

  useEffect(() => {
    dispatch(fetchImmovables(id, UserTypes.GENERATOR));

    return () => { dispatch(setImmovables([])); };
  }, []);

  return {
    id,
    isLoading,
    immovables,
  };
};
