import getCalendar from '../services/getCalendar';
import { setCalendarOptions, setIsLoading } from '../store/calendar/actions';

const fetchCalendarData = async (dispatch: any, token: string) => {
  dispatch(setIsLoading(true));
  const data = await getCalendar(token);

  dispatch(setCalendarOptions(data));
  dispatch(setIsLoading(false));
};

export default fetchCalendarData;
