import moveCalendarCardService from '../services/moveCalendarCard';
import { setEditAppointmens } from '../store/scheduler/actions';

const moveCalendarCard = async (
  dispatch: any,
  token: string,
  bodyData: {
    date_time: string;
    room_id: number;
  },
  id: number
) => {
  const { success, data } = await moveCalendarCardService(token, bodyData, id);

  if (success) {
    dispatch(setEditAppointmens(data));
  }
};

export default moveCalendarCard;
