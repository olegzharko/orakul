import { useSelector } from 'react-redux';
import { State } from '../../../../../../../../store/types';

export type Props = {
  rows: any;
  columns: any;
};

export const useGridTable = () => {
  const newSelectedAppointment = useSelector(
    (state: State) => state.scheduler.newSelectedAppointment
  );

  return { newSelectedAppointment };
};
