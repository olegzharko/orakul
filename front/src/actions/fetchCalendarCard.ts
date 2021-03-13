import { setEditAppointmentData } from '../store/scheduler/actions';
import getCalendarCard from '../services/getCalendarCard';

const fetchCalendarCard = async (dispatch: any, token: string, id: string) => {
  const data = await getCalendarCard(token, id);
  dispatch(setEditAppointmentData(data));
};

export default fetchCalendarCard;
