import { UserTypes } from '../types';
import { DEFAULT_URL } from './Constants';
import requestApi from './utils/requestApi';

export default async function getAppointments(token: string, type: UserTypes) {
  try {
    const data = await requestApi({
      url: `${DEFAULT_URL}/api/cards/${type}`,
      headers: { Authorization: `Bearer ${token}` },
    });

    return data;
  } catch (err) {
    // eslint-disable-next-line no-console
    console.log(err);
    return null;
  }
}
