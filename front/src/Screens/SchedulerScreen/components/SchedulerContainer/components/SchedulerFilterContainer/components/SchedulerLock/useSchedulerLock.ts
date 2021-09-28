import { useCallback } from 'react';
import { useDispatch, useSelector } from 'react-redux';
import { setSchedulerLock } from '../../../../../../../../store/scheduler/actions';
import { State } from '../../../../../../../../store/types';

export const useSchedulerLock = () => {
  const dispatch = useDispatch();
  const { schedulerLock } = useSelector((state: State) => state.scheduler);

  const onClick = useCallback(() => {
    dispatch(setSchedulerLock(!schedulerLock));
  }, [dispatch, schedulerLock]);

  return { onClick, schedulerLock };
};
