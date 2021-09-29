import { NewCard } from '../../types';
import { DEFAULT_URL } from '../Constants';
import requestApi from '../utils/requestApi';

export default async function editCalendarCard(
  token: string,
  bodyData: NewCard,
  id: number
) {
  try {
    const data = await requestApi({
      url: `${DEFAULT_URL}/api/cards/${id}`,
      headers: { Authorization: `Bearer ${token}` },
      method: 'PUT',
      bodyData,
    });

    return data;
  } catch (err) {
    // eslint-disable-next-line no-console
    console.error(err);
    return null;
  }
}
