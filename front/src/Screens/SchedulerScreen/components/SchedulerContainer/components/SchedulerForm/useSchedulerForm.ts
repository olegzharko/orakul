import { useSelector } from 'react-redux';
import { State } from '../../../../../../store/types';

export const useSchedulerForm = () => {
  const newSelectedAppointment = useSelector(
    (state: State) => state.scheduler.newSelectedAppointment
  );

  return { newSelectedAppointment };
};
