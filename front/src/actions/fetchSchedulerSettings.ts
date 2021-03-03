import getCalendar from '../services/getCalendar';
import { setSchedulerOptions, setIsLoading } from '../store/scheduler/actions';

const fetchSchedulerSettings = async (dispatch: any, token: string) => {
  dispatch(setIsLoading(true));
  const data = await getCalendar(token);

  dispatch(setSchedulerOptions(data));
  dispatch(setIsLoading(false));
};

export default fetchSchedulerSettings;
