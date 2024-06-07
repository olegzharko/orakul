import { useSelector, useDispatch } from 'react-redux';
import { useCallback, useState, useEffect } from 'react';

import { SelectItem } from '../../../../../../../../../../../../../../../types';
import { State } from '../../../../../../../../../../../../../../../store/types';
import { setModalInfo } from '../../../../../../../../../../../../../../../store/main/actions';
import reqNativeClientAddress from '../../../../../../../../../../../../../../../services/generator/Client/reqNativeClientAddress';
import reqClientCities from '../../../../../../../../../../../../../../../services/generator/Client/reqClientCities';
import reqClientDistricts from '../../../../../../../../../../../../../../../services/generator/Client/reqClientDistricts';

type Data = {
  native_region_id: string | null,
  native_city_id: string | null,
  native_address_type_id: string | null,
  native_address: string | null,
  native_building_type_id: string | null,
  native_building_num: string | null,
  native_building_part_id: string | null,
  native_building_part_num: string | null,
  native_apartment_type_id: string | null,
  native_apartment_num: string | null,
  native_district_id: string | null,
}
interface InitialData extends Data {
  native_registration: boolean,
  native_actual: boolean,
  regions?: SelectItem[],
  address_type?: SelectItem[],
  building_type?: SelectItem[],
  apartment_type?: SelectItem[],
  building_part?: SelectItem[],
}

export type Props = {
  id: string;
  initialData?: InitialData;
}

export const useNativeAddress = ({ initialData, id }: Props) => {
  const dispatch = useDispatch();
  const { token } = useSelector((state: State) => state.main.user);

  const [showModal, setShowModal] = useState<boolean>(false);

  const [regions, setNativeRegions] = useState<SelectItem[]>([]);
  const [cities, setNativeCities] = useState<SelectItem[]>([]);
  const [districts, setNativeDistricts] = useState<SelectItem[]>([]);
  const [addressType, setNativeAddressType] = useState<SelectItem[]>([]);
  const [buildingType, setNativeBuildingType] = useState<SelectItem[]>([]);
  const [buildingPartType, setNativeBuildingPartType] = useState<SelectItem[]>([]);
  const [apartmentType, setNativeApartmentType] = useState<SelectItem[]>([]);
  const [native_registration, setNativeRegistration] = useState<boolean>(false);
  const [native_actual, setNativeActual] = useState<boolean>(false);
  const [data, setData] = useState<Data>({
    native_region_id: null,
    native_city_id: null,
    native_address_type_id: null,
    native_address: null,
    native_building_type_id: null,
    native_building_num: null,
    native_building_part_id: null,
    native_building_part_num: null,
    native_apartment_type_id: null,
    native_apartment_num: null,
    native_district_id: null,
  });

  const onClear = useCallback(() => {
    setData({
      native_region_id: null,
      native_city_id: null,
      native_address_type_id: null,
      native_address: null,
      native_building_type_id: null,
      native_building_num: null,
      native_building_part_id: null,
      native_building_part_num: null,
      native_apartment_type_id: null,
      native_apartment_num: null,
      native_district_id: null,
    });
  }, []);

  const onSave = useCallback(async () => {
    if (token) {
      const bodyData = {
        ...data,
        native_registration,
      };

      const { success, message } = await reqNativeClientAddress(token, id, 'PUT', bodyData);
      dispatch(
        setModalInfo({
          open: true,
          success,
          message,
        })
      );
    }
  }, [token, data, native_registration, id, dispatch]);

  const onRegionChange = useCallback((value) => {
    setData({ ...data, native_region_id: value, native_district_id: null, native_city_id: null });
  }, [data]);

  const onDistrictChange = useCallback((value) => {
    setData({ ...data, native_district_id: value, native_city_id: null });
  }, [data]);

  useEffect(() => {
    setNativeRegions(initialData?.regions || []);
    setNativeAddressType(initialData?.address_type || []);
    setNativeBuildingType(initialData?.building_type || []);
    setNativeBuildingPartType(initialData?.building_part || []);
    setNativeApartmentType(initialData?.apartment_type || []);
    setNativeRegistration(initialData?.native_registration || false);
    setNativeActual(initialData?.native_actual || false);
    setData({
      native_region_id: initialData?.native_region_id || null,
      native_city_id: initialData?.native_city_id || null,
      native_address_type_id: initialData?.native_address_type_id || null,
      native_address: initialData?.native_address || null,
      native_building_type_id: initialData?.native_building_type_id || null,
      native_building_num: initialData?.native_building_num || null,
      native_building_part_id: initialData?.native_building_part_id || null,
      native_building_part_num: initialData?.native_building_part_num || null,
      native_apartment_type_id: initialData?.native_apartment_type_id || null,
      native_apartment_num: initialData?.native_apartment_num || null,
      native_district_id: initialData?.native_district_id || null,
    });
  }, [initialData]);

  // Change district and city when changed region
  useEffect(() => {
    if (showModal) return;
    // get DISTRICTS
    (async () => {
      if (token && data.native_region_id) {
        const res = await reqClientDistricts(token, data.native_region_id);

        if (res.success) {
          setNativeDistricts(res.data);
        }
      }
    })();

    // get CITIES
    (async () => {
      if (token && data.native_region_id) {
        const res = await reqClientCities(token, data.native_region_id, data.native_district_id);

        if (res.success) {
          setNativeCities(res.data);
        }
      }
    })();
  }, [token, data.native_region_id, data.native_district_id, showModal]);

  return {
    regions,
    cities,
    districts,
    addressType,
    buildingType,
    buildingPartType,
    apartmentType,
    data,
    showModal,
    native_registration,
    native_actual,
    setShowModal,
    setData,
    onRegionChange,
    onDistrictChange,
    onClear,
    onSave,
    setNativeRegistration,
    setNativeActual,
  };
};
