import setSchedulerFilter from '../services/setSchedulerFilter';
import { setAppointments } from '../store/scheduler/actions';

const fetchAppointmentsByFilter = async (
  dispatch: any,
  token: string,
  bodyData: any
) => {
  const { data, success } = await setSchedulerFilter(token, bodyData);

  if (success) {
    dispatch(setAppointments(Object.values(data)));
  }
};

export default fetchAppointmentsByFilter;
