import { DEFAULT_URL } from '../../Constants';
import requestApi from '../../utils/requestApi';

export default async function reqClientName(
  token: string,
  cardId: string,
  clientId: string,
  method: 'GET' | 'PUT' | 'DELETE' | undefined = 'GET',
  bodyData?: any
) {
  try {
    const url = method === 'DELETE' ? `/api/generator/client/delete/${clientId}/${cardId}` : `/api/generator/client/name/${clientId}`;

    const data = await requestApi({
      url: `${DEFAULT_URL}${url}`,
      headers: { Authorization: `Bearer ${token}` },
      method,
      bodyData,
    });

    return data;
  } catch (err) {
    // eslint-disable-next-line no-console
    console.log(err);
    return null;
  }
}
