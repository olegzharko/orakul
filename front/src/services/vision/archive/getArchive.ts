import { DEFAULT_URL } from '../../Constants';
import requestApi from '../../utils/requestApi';

export default async function getArchive(token: string) {
  const res = await requestApi({
    url: `${DEFAULT_URL}/api/bank/data`,
    headers: { Authorization: `Bearer ${token}` },
  });

  if (!res.success) throw new Error(res.message);

  return res.data;
}
