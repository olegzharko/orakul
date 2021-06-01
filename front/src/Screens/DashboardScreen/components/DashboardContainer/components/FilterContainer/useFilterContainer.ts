import { useCallback, useState } from 'react';
import { useDispatch, useSelector } from 'react-redux';
import { fetchAppointmentsByContracts, fetchAppointmentsByFilter } from '../../../../../../store/appointments/actions';
import { FilterData, State } from '../../../../../../store/types';

export const useFilterContainer = () => {
  const dispatch = useDispatch();
  const { filterInitialData } = useSelector((state: State) => state.filter);

  const onFilterDataChange = useCallback((data: FilterData) => {
    dispatch(fetchAppointmentsByFilter(data));
  }, []);

  const onContractsFilterChange = useCallback((url: string) => {
    dispatch(fetchAppointmentsByContracts(url));
  }, []);

  return {
    filterInitialData,
    onFilterDataChange,
    onContractsFilterChange,
  };
};
