import { useDispatch } from 'react-redux';
import { useCallback, useState } from 'react';
import { FilterData } from '../../../../../../../../store/types';
import { fetchAppointmentsByFilter } from '../../../../../../../../store/appointments/actions';

export const useSchedulerFilter = () => {
  const dispatch = useDispatch();

  const onFilterDataChange = useCallback((data: FilterData) => {
    dispatch(fetchAppointmentsByFilter(data));
  }, [dispatch]);

  return { onFilterDataChange };
};
