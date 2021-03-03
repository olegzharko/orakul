import { DEFAULT_URL } from './Constants';
import requestApi from './utils/requestApi';

export default async function getDeveloperInfo(token: string, id: number) {
  try {
    console.log(id);
    const data = await requestApi({
      url: `${DEFAULT_URL}/api/filter/developer/info/${id}`,
      headers: { Authorization: `Bearer ${token}` },
    });

    return data;
  } catch (err) {
    // eslint-disable-next-line no-console
    console.log(err);
    return null;
  }
}
