import { DEFAULT_URL } from '../../Constants';
import requestApi from '../../utils/requestApi';

export default async function reqClientName(
  token: string,
  clientType: string,
  clientId: string,
  method: 'GET' | 'PUT' | undefined = 'GET',
  bodyData?: any
) {
  try {
    const data = await requestApi({
      url: `${DEFAULT_URL}/api/notarize/client/${clientType}/full-name/${clientId}`,
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