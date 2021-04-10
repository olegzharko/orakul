import { DEFAULT_URL } from '../../Constants';
import requestApi from '../../utils/requestApi';

export default async function reqDeveloper(
  token: string,
  developerId: string,
  cardId: string,
  method: 'POST' | 'GET' = 'GET',
  bodyData?: any,
) {
  try {
    const data = await requestApi({
      url: `${DEFAULT_URL}/api/generator/developer/main/${developerId}/${cardId}`,
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
