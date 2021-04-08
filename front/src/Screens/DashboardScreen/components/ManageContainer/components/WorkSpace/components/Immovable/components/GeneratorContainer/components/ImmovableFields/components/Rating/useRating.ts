import { useCallback, useEffect, useState } from 'react';
import { useDispatch, useSelector } from 'react-redux';
import { changeMonthWitDate, formatDate } from '../../../../../../../../../../../../../../utils/formatDates';
import { SelectItem } from '../../../../../../../../../../../../../../types';
import { setModalInfo } from '../../../../../../../../../../../../../../store/main/actions';
import { State } from '../../../../../../../../../../../../../../store/types';
import reqImmovableRating from '../../../../../../../../../../../../../../services/generator/Immovable/reqImmovableRating';

type InitialData = {
  property_valuation_id: number | null,
  date: any,
  price: number | null,
  property_valuation?: SelectItem[]
}

export type Props = {
  id: string,
  initialData?: InitialData,
}

export const useRating = ({ initialData, id }: Props) => {
  const dispatch = useDispatch();
  const { token } = useSelector((state: State) => state.main.user);

  // Initial data
  const [valuation, setValuation] = useState<SelectItem[]>([]);
  const [data, setData] = useState<InitialData>({
    property_valuation_id: null,
    date: null,
    price: null,
  });

  const onClear = useCallback(() => {
    setData({
      property_valuation_id: null,
      date: null,
      price: null,
    });
  }, []);

  const onSave = useCallback(async () => {
    if (token) {
      const reqData = {
        ...data,
        date: formatDate(data.date),
      };

      const { success, message } = await reqImmovableRating(token, id, 'PUT', reqData);
      dispatch(
        setModalInfo({
          open: true,
          success,
          message,
        })
      );
    }
  }, [data, token]);

  useEffect(() => {
    setValuation(initialData?.property_valuation || []);
    setData({
      property_valuation_id: initialData?.property_valuation_id || null,
      date: initialData?.date ? new Date(changeMonthWitDate(initialData?.date)) : null,
      price: initialData?.price || null,
    });
  }, [initialData]);

  return {
    data,
    valuation,
    setData,
    onClear,
    onSave,
  };
};
