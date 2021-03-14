import getDeveloperInfo from '../services/getDeveloperInfo';
import { setDevelopersInfo } from '../store/scheduler/actions';

const fetchCalendarCard = async (
  dispatch: any,
  token: string,
  id: number,
  notDispatch: boolean = false
) => {
  const data = await getDeveloperInfo(token, id);

  if (!notDispatch) {
    dispatch(setDevelopersInfo(data));
  }

  return data;
};

export default fetchCalendarCard;
