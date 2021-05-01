import { useSelector, useDispatch } from 'react-redux';
import { useCallback, useState, useEffect } from 'react';
import { SelectItem } from '../../../../../../../../../../../../../../types';
import { State } from '../../../../../../../../../../../../../../store/types';
import { setModalInfo } from '../../../../../../../../../../../../../../store/main/actions';
import reqClientAddress from '../../../../../../../../../../../../../../services/generator/Client/reqClientAddress';
import reqClientCities from '../../../../../../../../../../../../../../services/generator/Client/reqClientCities';

type ActualInitialData = {
  actual_region_id: string | null,
  actual_city_id: string | null,
  actual_address_type_id: string | null,
  actual_address: string | null,
  actual_building_type_id: string | null,
  actual_building_num: string | null,
  actual_apartment_type_id: string | null,
  actual_apartment_num: string | null,
}

type Data = {
  region_id: string | null,
  city_id: string | null,
  address_type_id: string | null,
  address: string | null,
  building_type_id: string | null,
  building_num: string | null,
  apartment_type_id: string | null,
  apartment_num: string | null,
}
interface InitialData extends ActualInitialData, Data {
  registration: boolean,
  actual: boolean,
  regions?: SelectItem[],
  address_type?: SelectItem[],
  building_type?: SelectItem[],
  apartment_type?: SelectItem[],
}

export type Props = {
  id: string;
  initialData?: InitialData;
}

export const useAddress = ({ initialData, id }: Props) => {
  const dispatch = useDispatch();
  const { token } = useSelector((state: State) => state.main.user);

  const [showModal, setShowModal] = useState<boolean>(false);

  const [regions, setRegions] = useState<SelectItem[]>([]);
  const [actualRegions, setActualRegions] = useState<SelectItem[]>([]);
  const [cities, setCities] = useState<SelectItem[]>([]);
  const [actualCities, setActualCities] = useState<SelectItem[]>([]);
  const [addressType, setAddressType] = useState<SelectItem[]>([]);
  const [buildingType, setBuildingType] = useState<SelectItem[]>([]);
  const [apartmentType, setApartmentType] = useState<SelectItem[]>([]);
  const [registration, setRegistration] = useState<boolean>(false);
  const [actual, setActual] = useState<boolean>(false);
  const [data, setData] = useState<Data>({
    region_id: null,
    city_id: null,
    address_type_id: null,
    address: null,
    building_type_id: null,
    building_num: null,
    apartment_type_id: null,
    apartment_num: null,
  });
  const [actualData, setActualData] = useState<ActualInitialData>({
    actual_region_id: null,
    actual_city_id: null,
    actual_address_type_id: null,
    actual_address: null,
    actual_building_type_id: null,
    actual_building_num: null,
    actual_apartment_type_id: null,
    actual_apartment_num: null,
  });

  useEffect(() => {
    setRegions(initialData?.regions || []);
    setActualRegions(initialData?.regions || []);
    setAddressType(initialData?.address_type || []);
    setBuildingType(initialData?.building_type || []);
    setApartmentType(initialData?.apartment_type || []);
    setRegistration(initialData?.registration || false);
    setActual(initialData?.actual || false);
    setData({
      region_id: initialData?.region_id || null,
      city_id: initialData?.city_id || null,
      address_type_id: initialData?.address_type_id || null,
      address: initialData?.address || null,
      building_type_id: initialData?.building_type_id || null,
      building_num: initialData?.building_num || null,
      apartment_type_id: initialData?.apartment_type_id || null,
      apartment_num: initialData?.apartment_num || null,
    });
    setActualData({
      actual_region_id: initialData?.actual_region_id || null,
      actual_city_id: initialData?.actual_city_id || null,
      actual_address_type_id: initialData?.actual_address_type_id || null,
      actual_address: initialData?.actual_address || null,
      actual_building_type_id: initialData?.actual_building_type_id || null,
      actual_building_num: initialData?.actual_building_num || null,
      actual_apartment_type_id: initialData?.actual_apartment_type_id || null,
      actual_apartment_num: initialData?.actual_apartment_num || null,
    });
  }, [initialData]);

  useEffect(() => {
    if (showModal) return;

    // get CITIES
    (async () => {
      if (token && data.region_id) {
        const res = await reqClientCities(token, data.region_id);

        if (res.success) {
          setCities(res.data);
        }
      }
    })();
  }, [token, data.region_id, showModal]);

  useEffect(() => {
    if (showModal) return;

    // get CITIES
    (async () => {
      if (token && actualData.actual_region_id) {
        const res = await reqClientCities(token, actualData.actual_region_id);

        if (res.success) {
          setActualCities(res.data);
        }
      }
    })();
  }, [token, actualData.actual_region_id, showModal]);

  const onClear = useCallback(() => {
    setData({
      region_id: null,
      city_id: null,
      address_type_id: null,
      address: null,
      building_type_id: null,
      building_num: null,
      apartment_type_id: null,
      apartment_num: null,
    });

    setActualData({
      actual_region_id: null,
      actual_city_id: null,
      actual_address_type_id: null,
      actual_address: null,
      actual_building_type_id: null,
      actual_building_num: null,
      actual_apartment_type_id: null,
      actual_apartment_num: null,
    });
  }, []);

  const onSave = useCallback(async () => {
    if (token) {
      const bodyData = {
        ...data,
        ...actualData,
        actual,
        registration,
      };

      const { success, message } = await reqClientAddress(token, id, 'PUT', bodyData);
      dispatch(
        setModalInfo({
          open: true,
          success,
          message,
        })
      );
    }
  }, [data, actualData, actual, registration, token]);

  return {
    regions,
    actualRegions,
    cities,
    actualCities,
    addressType,
    buildingType,
    apartmentType,
    data,
    actualData,
    showModal,
    registration,
    actual,
    setShowModal,
    setData,
    setActualData,
    onClear,
    onSave,
    setRegistration,
    setActual,
  };
};
