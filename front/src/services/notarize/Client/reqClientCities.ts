import { DEFAULT_URL } from '../../Constants';
import requestApi from '../../utils/requestApi';

export default async function reqClientCities(
  token: string,
  regionId: string | null,
  districtId: string | null,
) {
  try {
    const data = await requestApi({
      url: `${DEFAULT_URL}/api/generator/client/cities/${regionId}${districtId ? `/${districtId}` : ''}`,
      headers: { Authorization: `Bearer ${token}` },
    });

    return data;
  } catch (err) {
    // eslint-disable-next-line no-console
    console.error(err);
    return null;
  }
}
