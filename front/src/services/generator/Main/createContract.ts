import { DEFAULT_URL } from '../../Constants';
import requestApi from '../../utils/requestApi';

export default async function createContract(token: string, id: string) {
  try {
    const data = await requestApi({
      url: `${DEFAULT_URL}/create/${id}`,
      headers: { Authorization: `Bearer ${token}` },
    });

    return data;
  } catch (err) {
    // eslint-disable-next-line no-console
    console.error(err);
    return null;
  }
}
