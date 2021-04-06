import { useSelector, useDispatch } from 'react-redux';
import { useCallback, useState, useEffect } from 'react';
import { SelectItem } from '../../../../../../../../../../../../../../types';
import { State } from '../../../../../../../../../../../../../../store/types';
import { setModalInfo } from '../../../../../../../../../../../../../../store/main/actions';
import reqClientAddress from '../../../../../../../../../../../../../../services/generator/Client/reqClientAddress';
import reqClientCities from '../../../../../../../../../../../../../../services/generator/Client/reqClientCities';

type InitialData = {
  regions?: SelectItem[],
  address_type?: SelectItem[],
  building_type?: SelectItem[],
  apartment_type?: SelectItem[],
  region_id: string,
  city_id: string,
  address_type_id: string,
  address: string,
  building_type_id: string,
  building_num: string,
  apartment_type_id: string,
  apartment_num: string,
}

export type Props = {
  id: string;
  initialData?: InitialData;
}

export const useAddress = ({ initialData, id }: Props) => {
  const dispatch = useDispatch();
  const { token } = useSelector((state: State) => state.main.user);

  const [regions, setRegions] = useState<SelectItem[]>([]);
  const [cities, setCities] = useState<SelectItem[]>([]);
  const [addressType, setAddressType] = useState<SelectItem[]>([]);
  const [buildingType, setBuildingType] = useState<SelectItem[]>([]);
  const [apartmentType, setApartmentType] = useState<SelectItem[]>([]);
  const [data, setData] = useState<InitialData>({
    region_id: '',
    city_id: '',
    address_type_id: '',
    address: '',
    building_type_id: '',
    building_num: '',
    apartment_type_id: '',
    apartment_num: '',
  });

  useEffect(() => {
    setRegions(initialData?.regions || []);
    setAddressType(initialData?.address_type || []);
    setBuildingType(initialData?.building_type || []);
    setApartmentType(initialData?.apartment_type || []);
    setData({
      region_id: initialData?.region_id || '',
      city_id: initialData?.city_id || '',
      address_type_id: initialData?.address_type_id || '',
      address: initialData?.address || '',
      building_type_id: initialData?.building_type_id || '',
      building_num: initialData?.building_num || '',
      apartment_type_id: initialData?.apartment_type_id || '',
      apartment_num: initialData?.apartment_num || '',
    });
  }, [initialData]);

  useEffect(() => {
    // get CITIES
    (async () => {
      if (token && data.region_id) {
        const res = await reqClientCities(token, data.region_id);

        if (res.success) {
          setCities(res.data);
        }
      }
    })();
  }, [token, data.region_id]);

  const onClear = useCallback(() => {
    setData({
      region_id: '',
      city_id: '',
      address_type_id: '',
      address: '',
      building_type_id: '',
      building_num: '',
      apartment_type_id: '',
      apartment_num: '',
    });
  }, []);

  const onSave = useCallback(async () => {
    if (token) {
      const { success, message } = await reqClientAddress(token, id, 'PUT', data);
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
    regions,
    cities,
    addressType,
    buildingType,
    apartmentType,
    data,
    setData,
    onClear,
    onSave,
  };
};
