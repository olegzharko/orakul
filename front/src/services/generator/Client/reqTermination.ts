import { DEFAULT_URL } from '../../Constants';
import requestApi from '../../utils/requestApi';

export default async function reqTermination(
  token: string,
  cardId: string,
  userId: string,
  method: 'GET' | 'PUT' | undefined = 'GET',
  bodyData?: any
) {
  try {
    const data = await requestApi({
      url: `${DEFAULT_URL}/api/generator/client/termination/${cardId}/${userId}`,
      headers: { Authorization: `Bearer ${token}` },
      method,
      bodyData,
    });

    return data;
  } catch (err) {
    // eslint-disable-next-line no-console
    console.error(err);
    return null;
  }
}
