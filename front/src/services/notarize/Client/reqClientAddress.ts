import { DEFAULT_URL } from '../../Constants';
import requestApi from '../../utils/requestApi';

export default async function reqClientAddress(
  token: string,
  clientType: string,
  cardId: string,
  method: 'GET' | 'PUT' | undefined = 'GET',
  bodyData?: any,
) {
  try {
    const data = await requestApi({
      url: `${DEFAULT_URL}/api/notarize/client/${clientType}/address/${cardId}`,
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
