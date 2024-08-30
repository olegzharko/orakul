import { UserTypes } from '../../../types';
import { DEFAULT_URL } from '../../Constants';
import requestApi from '../../utils/requestApi';

export default async function getClients(token: string, id: string, userType: UserTypes) {
  try {
    const url = userType === UserTypes.MANAGER ? `/api/manager/clients/${id}` : `/api/generator/client/main/${id}`;
    const data = await requestApi({
      url: `${DEFAULT_URL}${url}`,
      headers: { Authorization: `Bearer ${token}` },
    });

    return data;
  } catch (err) {
    // eslint-disable-next-line no-console
    console.error(err);
    return null;
  }
}
