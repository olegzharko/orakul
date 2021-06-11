import { useCallback, useState, useEffect } from 'react';
import { useDispatch, useSelector } from 'react-redux';
import reqImmovableTermination from '../../../../../../../../../../../../../../services/generator/Immovable/reqImmovableTermination';
import { setModalInfo } from '../../../../../../../../../../../../../../store/main/actions';
import { State } from '../../../../../../../../../../../../../../store/types';
import { SelectItem } from '../../../../../../../../../../../../../../types';
import { changeMonthWitDate, formatDate } from '../../../../../../../../../../../../../../utils/formatDates';

type InitialData = {
  notary_id: number | null,
  reg_date: any,
  reg_number: string | null,
  price: string | null,
  notary?: SelectItem[],
}

export type Props = {
  id: string,
  initialData?: InitialData,
}

export const useTermination = ({ id, initialData }: Props) => {
  const dispatch = useDispatch();
  const { token } = useSelector((state: State) => state.main.user);

  const [notaries, setNotaries] = useState<SelectItem[]>([]);
  const [data, setData] = useState<InitialData>({
    notary_id: null,
    reg_date: null,
    reg_number: null,
    price: null,
  });

  const onClear = useCallback(() => {
    setData({
      notary_id: null,
      reg_date: null,
      reg_number: null,
      price: null,
    });
  }, []);

  const onSave = useCallback(async () => {
    if (token) {
      const reqData = {
        ...data,
        reg_date: formatDate(data.reg_date),
      };

      const { success, message } = await reqImmovableTermination(token, id, 'PUT', reqData);
      dispatch(
        setModalInfo({
          open: true,
          success,
          message,
        })
      );
    }
  }, [data]);

  useEffect(() => {
    setNotaries(initialData?.notary || []);
    setData({
      notary_id: initialData?.notary_id || null,
      reg_number: initialData?.reg_number || null,
      price: initialData?.price || null,
      reg_date: initialData?.reg_date ? changeMonthWitDate(initialData?.reg_date) : null,
    });
  }, [initialData]);

  return {
    notaries,
    data,
    onClear,
    onSave,
    setData,
  };
};
