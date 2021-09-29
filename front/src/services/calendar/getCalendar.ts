import { DEFAULT_URL } from '../Constants';
import requestApi from '../utils/requestApi';

export default async function getCalendar(token: string) {
  try {
    const data = await requestApi({
      url: `${DEFAULT_URL}/api/calendar`,
      headers: { Authorization: `Bearer ${token}` },
    });

    return data.data;
  } catch (err) {
    // eslint-disable-next-line no-console
    console.error(err);
    return null;
  }
}
