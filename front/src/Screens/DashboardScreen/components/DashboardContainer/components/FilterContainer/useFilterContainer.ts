import { useCallback, useState } from 'react';
import { useDispatch } from 'react-redux';
import { fetchAppointmentsByFilter } from '../../../../../../store/appointments/actions';
import { FilterData } from '../../../../../../store/types';

export const useFilterContainer = () => {
  const dispatch = useDispatch();
  const [filterData, setFilterData] = useState<FilterData>();

  const onFilterDataChange = useCallback((data: FilterData) => {
    setFilterData(data);
  }, []);

  const onFilterSubmit = useCallback(() => {
    if (filterData) {
      dispatch(fetchAppointmentsByFilter('generator', filterData));
    }
  }, [filterData]);

  return { onFilterDataChange, onFilterSubmit };
};
