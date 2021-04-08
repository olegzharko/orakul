import { useCallback, useEffect, useMemo, useState } from 'react';
import { useDispatch, useSelector } from 'react-redux';
import reqImmovableGeneral from '../../../../../../../../../../../../../../services/generator/Immovable/reqImmovableGeneral';
import { setModalInfo } from '../../../../../../../../../../../../../../store/main/actions';
import { State } from '../../../../../../../../../../../../../../store/types';
import { SelectItem } from '../../../../../../../../../../../../../../types';

type InitialData = {
  imm_type_id: number | null;
  building_id: string;
  roominess_id: string;
  imm_number: string;
  registration_number: string;
  price_dollar: string;
  price_grn: string;
  reserve_grn: string;
  reserve_dollar: string;
  m2_grn: string;
  m2_dollar: string;
  total_space: string;
  living_space: string;
  floor: string;
  section: any;
  roominess?: SelectItem[],
  building?: SelectItem[],
  imm_type?: SelectItem[]
}

export type Props = {
  id: string,
  initialData?: InitialData,
}

export const useGeneral = ({ initialData, id }: Props) => {
  const dispatch = useDispatch();
  const { token } = useSelector((state: State) => state.main.user);

  // Initial data
  const [roominess, setRoominess] = useState<SelectItem[]>([]);
  const [building, setBuilding] = useState<SelectItem[]>([]);
  const [immType, setImmType] = useState<SelectItem[]>([]);
  const [data, setData] = useState<InitialData>({
    imm_type_id: null,
    building_id: '',
    roominess_id: '',
    imm_number: '',
    registration_number: '',
    price_dollar: '',
    price_grn: '',
    reserve_grn: '',
    reserve_dollar: '',
    m2_grn: '',
    m2_dollar: '',
    total_space: '',
    living_space: '',
    floor: '',
    section: '',
  });

  const onClear = useCallback(() => {
    setData({
      imm_type_id: null,
      building_id: '',
      roominess_id: '',
      imm_number: '',
      registration_number: '',
      price_dollar: '',
      price_grn: '',
      reserve_grn: '',
      reserve_dollar: '',
      m2_grn: '',
      m2_dollar: '',
      total_space: '',
      living_space: '',
      floor: '',
      section: '',
    });
  }, []);

  const onSave = useCallback(async () => {
    if (token) {
      const { success, message } = await reqImmovableGeneral(token, id, 'PUT', data);
      dispatch(
        setModalInfo({
          open: true,
          success,
          message,
        })
      );
    }
  }, [data, token]);

  const isSaveButtonDisable = useMemo(
    () => !data.building_id
      || !data.imm_number
      || !data.imm_type_id,
    [data.building_id, data.imm_number, data.imm_type_id]
  );

  useEffect(() => {
    setRoominess(initialData?.roominess || []);
    setBuilding(initialData?.building || []);
    setImmType(initialData?.imm_type || []);
    setData({
      imm_type_id: initialData?.imm_type_id || null,
      building_id: initialData?.building_id || '',
      roominess_id: initialData?.roominess_id || '',
      imm_number: initialData?.imm_number || '',
      registration_number: initialData?.registration_number || '',
      price_dollar: initialData?.price_dollar || '',
      price_grn: initialData?.price_grn || '',
      reserve_grn: initialData?.reserve_grn || '',
      reserve_dollar: initialData?.reserve_dollar || '',
      m2_grn: initialData?.m2_grn || '',
      m2_dollar: initialData?.m2_dollar || '',
      total_space: initialData?.total_space || '',
      living_space: initialData?.living_space || '',
      floor: initialData?.floor || '',
      section: initialData?.section || '',
    });
  }, [initialData]);

  return {
    roominess,
    building,
    immType,
    data,
    isSaveButtonDisable,
    setData,
    onClear,
    onSave,
  };
};
