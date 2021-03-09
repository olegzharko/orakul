import createNewCardService from '../services/createNewCard';
import { addNewAppointment, setModalInfo } from '../store/scheduler/actions';
import { NewCard } from '../types';

const createNewCard = async (dispatch: any, token: string, data: NewCard) => {
  const res = await createNewCardService(token, data);
  dispatch(
    setModalInfo({
      open: true,
      success: res.success,
      message: res.message,
    })
  );
  dispatch(addNewAppointment(res.data));
  return { success: res.success };
};

export default createNewCard;
