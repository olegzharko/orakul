import { DEFAULT_URL } from '../../Constants';
import requestApi from '../../utils/requestApi';

export default async function getDealDetail(token: string, room: string, dealId: string) {
  const res = await requestApi({
    url: `${DEFAULT_URL}/api/${room}/detail/${dealId}`,
    headers: { Authorization: `Bearer ${token}` },
  });

  if (!res.success) throw new Error(res.message);

  return res.data;
}
