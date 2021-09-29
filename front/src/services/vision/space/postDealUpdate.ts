import { DEFAULT_URL } from '../../Constants';
import requestApi from '../../utils/requestApi';

export type PostDealUpdate = {
  card_id: number;
  number_of_people: number;
  children: boolean;
}

export default async function postDealUpdate(token: string, bodyData: PostDealUpdate) {
  const data = await requestApi({
    url: `${DEFAULT_URL}/api/deal/update`,
    headers: { Authorization: `Bearer ${token}` },
    method: 'PUT',
    bodyData,
  });

  if (!data.success) throw new Error('Нові дані не вдалося зберегти: проблема на боці сервера.');

  return data.data;
}
