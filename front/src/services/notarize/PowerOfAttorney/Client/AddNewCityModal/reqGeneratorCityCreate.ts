import { DEFAULT_URL } from '../../../../Constants';
import requestApi from '../../../../utils/requestApi';

export default async function reqGeneratorCityCreate(
  token: string,
  method: 'GET' | 'POST' | undefined = 'GET',
  bodyData?: any
) {
  try {
    const data = await requestApi({
      url: `${DEFAULT_URL}/api/generator/city/create`,
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
