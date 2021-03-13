import editCalendarCardService from '../services/editCalendarCard';
import { setModalInfo } from '../store/scheduler/actions';
import { NewCard } from '../types';

const editCalendarCard = async (
  dispatch: any,
  token: string,
  bodyData: NewCard,
  id: number
) => {
  const res = await editCalendarCardService(token, bodyData, id);

  dispatch(
    setModalInfo({
      open: true,
      success: res.success,
      message: res.message,
    })
  );
};

export default editCalendarCard;
