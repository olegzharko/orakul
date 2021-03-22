import { useDispatch } from 'react-redux';
import { useCallback } from 'react';
import { FilterData } from '../../../../../../../../store/types';
import { fetchAppointmentsByFilter } from '../../../../../../../../store/appointments/actions';

export const useSchedulerFilter = () => {
  const dispatch = useDispatch();

  const onFilterDataChange = useCallback((data: FilterData) => {
    dispatch(fetchAppointmentsByFilter('calendar', data));
  }, []);

  return { onFilterDataChange };
};
