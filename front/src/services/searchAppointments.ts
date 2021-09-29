import { UserTypes } from '../types';
import { DEFAULT_URL } from './Constants';
import requestApi from './utils/requestApi';

export default async function searchAppointments(
  token: string,
  bodyData: {
    text: string;
    type: UserTypes;
  }
) {
  try {
    const data = await requestApi({
      url: `${DEFAULT_URL}/api/filter/search`,
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
