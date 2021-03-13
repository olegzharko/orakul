import editCalendarCardService from '../services/editCalendarCard';
import { setEditAppointmens, setModalInfo } from '../store/scheduler/actions';
import { NewCard } from '../types';

const editCalendarCard = async (
  dispatch: any,
  token: string,
  bodyData: NewCard,
  id: number
) => {
  const { success, message, data } = await editCalendarCardService(
    token,
    bodyData,
    id
  );

  dispatch(
    setModalInfo({
      open: true,
      success,
      message,
    })
  );

  if (success) {
    dispatch(setEditAppointmens(data));
  }
};

export default editCalendarCard;
