import { DEFAULT_URL } from '../../Constants';
import requestApi from '../../utils/requestApi';

export default async function getDealDetail(token: string, dealId: string) {
  try {
    const data = await requestApi({
      url: `${DEFAULT_URL}/api/deal/detail/${dealId}`,
      headers: { Authorization: `Bearer ${token}` },
    });

    return data;
  } catch (err) {
    // eslint-disable-next-line no-console
    console.error(err);
    return null;
  }
}
