import getAppointments from '../services/getAppointments';
import { setAppointments, setIsLoading } from '../store/scheduler/actions';

const fetchAppointments = async (dispatch: any, token: string) => {
  dispatch(setIsLoading(true));
  const data = await getAppointments(token);

  dispatch(setAppointments(Object.values(data)));
  dispatch(setIsLoading(false));
};

export default fetchAppointments;
