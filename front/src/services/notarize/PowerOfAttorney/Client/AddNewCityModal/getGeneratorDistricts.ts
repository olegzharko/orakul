import { DEFAULT_URL } from '../../../../Constants';
import requestApi from '../../../../utils/requestApi';

export default async function getGeneratorDistricts(
  token: string,
  id: string,
) {
  try {
    const data = await requestApi({
      url: `${DEFAULT_URL}/api/generator/region/district/${id}`,
      headers: { Authorization: `Bearer ${token}` },
      method: 'GET',
    });

    return data;
  } catch (err) {
    // eslint-disable-next-line no-console
    console.error(err);
    return null;
  }
}
