import { NewCard } from '../../types';
import { DEFAULT_URL } from '../Constants';
import requestApi from '../utils/requestApi';

export default async function postStartIssuing(token: string, bodyData: NewCard) {
  try {
    const data = await requestApi({
      url: `${DEFAULT_URL}/api/deal/set/info`,
      headers: { Authorization: `Bearer ${token}` },
      method: 'POST',
      bodyData,
    });

    return data;
  } catch (err) {
    // eslint-disable-next-line no-console
    console.error(err);
    return null;
  }
}
