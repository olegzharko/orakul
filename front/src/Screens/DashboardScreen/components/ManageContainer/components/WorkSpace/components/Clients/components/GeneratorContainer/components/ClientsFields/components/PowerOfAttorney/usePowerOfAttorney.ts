import { useSelector, useDispatch } from 'react-redux';
import { useCallback, useState, useEffect } from 'react';
import { SelectItem } from '../../../../../../../../../../../../../../types';
import { State } from '../../../../../../../../../../../../../../store/types';
import { setModalInfo } from '../../../../../../../../../../../../../../store/main/actions';
import reqClientRepresentative from '../../../../../../../../../../../../../../services/generator/Client/reqClientRepresentative';
import { formatDate } from '../../../../../../../../../../../../../../utils/formatDates';

type InitialData = {
  notary_id: string,
  reg_num: string,
  reg_date: Date | null,
  notary?: SelectItem[],
  other_notary?: SelectItem[],
}

export type Props = {
  clientId: string;
  personId: string;
  initialData?: InitialData;
}

export const usePowerOfAttorney = ({ initialData, clientId, personId }: Props) => {
  const dispatch = useDispatch();
  const { token } = useSelector((state: State) => state.main.user);

  const [notary, setNotary] = useState<SelectItem[]>([]);
  const [otherNotary, setOtherNotary] = useState<SelectItem[]>([]);
  const [data, setData] = useState<InitialData>({
    notary_id: '',
    reg_num: '',
    reg_date: null,
  });

  useEffect(() => {
    setNotary(initialData?.notary || []);
    setOtherNotary(initialData?.other_notary || []);
    setData({
      notary_id: initialData?.notary_id || '',
      reg_num: initialData?.reg_num || '',
      reg_date: initialData?.reg_date ? new Date(initialData?.reg_date) : null,
    });
  }, [initialData]);

  const onClear = useCallback(() => {
    setData({
      notary_id: '',
      reg_num: '',
      reg_date: null,
    });
  }, []);

  const onSave = useCallback(async () => {
    if (token) {
      const reqData = {
        ...data,
        reg_date: data.reg_date ? formatDate(data.reg_date) : null,
      };

      const { success, message } = await reqClientRepresentative(token, clientId, personId, 'PUT', reqData);
      dispatch(
        setModalInfo({
          open: true,
          success,
          message,
        })
      );
    }
  }, [data, token]);

  return {
    data,
    notary,
    otherNotary,
    setData,
    onClear,
    onSave,
  };
};
