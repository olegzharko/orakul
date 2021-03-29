import { useDispatch } from 'react-redux';
import { useCallback, useState } from 'react';
import { FilterData } from '../../../../../../../../store/types';
import { fetchAppointmentsByFilter } from '../../../../../../../../store/appointments/actions';

export const useSchedulerFilter = () => {
  const [shouldRender, setShouldRender] = useState<boolean>(false);
  const dispatch = useDispatch();

  const onFilterDataChange = useCallback((data: FilterData) => {
    if (!shouldRender) {
      setShouldRender(true);
      return;
    }

    dispatch(fetchAppointmentsByFilter(data));
  }, [shouldRender]);

  return { onFilterDataChange };
};
