import { FilterData } from '../store/types';
import { UserTypes } from '../types';
import { DEFAULT_URL } from './Constants';
import requestApi from './utils/requestApi';

export default async function postAppointmentsByFilter(
  token: string,
  bodyData: FilterData & {user_type: UserTypes}
) {
  try {
    const data = await requestApi({
      url: `${DEFAULT_URL}/api/filter/sort`,
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
