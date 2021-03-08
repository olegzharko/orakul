import createNewCardService from '../services/createNewCard';
import { NewCard } from '../types';

const createNewCard = async (dispatch: any, token: string, data: NewCard) => {
  const res = await createNewCardService(token, data);
};

export default createNewCard;
