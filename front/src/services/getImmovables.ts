import { UserTypes } from '../types';
import { DEFAULT_URL } from './Constants';
import requestApi from './utils/requestApi';

export default async function getImmovables(token: string, id: string, userType: UserTypes) {
  try {
    const url = userType === UserTypes.MANAGER ? `/api/manager/immovables/${id}` : `/api/generator/immovable/main/${id}`;
    const data = await requestApi({
      url: `${DEFAULT_URL}${url}`,
      headers: { Authorization: `Bearer ${token}` },
    });

    return data;
  } catch (err) {
    // eslint-disable-next-line no-console
    console.log(err);
    return null;
  }
}
