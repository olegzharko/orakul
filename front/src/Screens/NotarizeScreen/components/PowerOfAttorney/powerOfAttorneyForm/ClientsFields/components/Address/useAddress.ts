import { useSelector, useDispatch } from 'react-redux';
import { useCallback, useState, useEffect } from 'react';
import { useParams } from 'react-router-dom'; // Third-party import should come first

import { SelectItem } from '../../../../../../../../types';
import { State } from '../../../../../../../../store/types';
import { setModalInfo } from '../../../../../../../../store/main/actions';
import reqClientAddress from '../../../../../../../../services/notarize/Client/reqClientAddress';
import reqClientCities from '../../../../../../../../services/notarize/Client/reqClientCities';
import reqClientDistricts from '../../../../../../../../services/notarize/Client/reqClientDistricts';

type ActualInitialData = {
  actual_region_id: string | null,
  actual_city_id: string | null,
  actual_address_type_id: string | null,
  actual_address: string | null,
  actual_building_type_id: string | null,
  actual_building_num: string | null,
  actual_building_part_id: string | null,
  actual_building_part_num: string | null,
  actual_apartment_type_id: string | null,
  actual_apartment_num: string | null,
  actual_district_id: string | null,
}

type Data = {
  region_id: string | null,
  city_id: string | null,
  address_type_id: string | null,
  address: string | null,
  building_type_id: string | null,
  building_num: string | null,
  building_part_id: string | null,
  building_part_num: string | null,
  apartment_type_id: string | null,
  apartment_num: string | null,
  district_id: string | null,
}
interface InitialData extends ActualInitialData, Data {
  registration: boolean,
  actual: boolean,
  regions?: SelectItem[],
  address_type?: SelectItem[],
  building_type?: SelectItem[],
  apartment_type?: SelectItem[],
  building_part?: SelectItem[],
}

export type Props = {
  initialData?: InitialData;
  headerColor?: string;
  clientType?: string;
}

export const useAddress = ({ initialData, clientType }: Props) => {
  const dispatch = useDispatch();
  const { token } = useSelector((state: State) => state.main.user);
  const { id } = useParams<{ id: string }>();

  const [showModal, setShowModal] = useState<boolean>(false);

  const [regions, setRegions] = useState<SelectItem[]>([]);
  const [actualRegions, setActualRegions] = useState<SelectItem[]>([]);
  const [cities, setCities] = useState<SelectItem[]>([]);
  const [actualCities, setActualCities] = useState<SelectItem[]>([]);
  const [districts, setDistricts] = useState<SelectItem[]>([]);
  const [actualDistricts, setActualDistricts] = useState<SelectItem[]>([]);
  const [addressType, setAddressType] = useState<SelectItem[]>([]);
  const [buildingType, setBuildingType] = useState<SelectItem[]>([]);
  const [buildingPartType, setBuildingPartType] = useState<SelectItem[]>([]);
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
    building_part_id: null,
    building_part_num: null,
    apartment_type_id: null,
    apartment_num: null,
    district_id: null,
  });
  const [actualData, setActualData] = useState<ActualInitialData>({
    actual_region_id: null,
    actual_city_id: null,
    actual_address_type_id: null,
    actual_address: null,
    actual_building_type_id: null,
    actual_building_num: null,
    actual_building_part_id: null,
    actual_building_part_num: null,
    actual_apartment_type_id: null,
    actual_apartment_num: null,
    actual_district_id: null,
  });

  const onClear = useCallback(() => {
    setData({
      region_id: null,
      city_id: null,
      address_type_id: null,
      address: null,
      building_type_id: null,
      building_num: null,
      building_part_id: null,
      building_part_num: null,
      apartment_type_id: null,
      apartment_num: null,
      district_id: null,
    });

    setActualData({
      actual_region_id: null,
      actual_city_id: null,
      actual_address_type_id: null,
      actual_address: null,
      actual_building_type_id: null,
      actual_building_num: null,
      actual_building_part_id: null,
      actual_building_part_num: null,
      actual_apartment_type_id: null,
      actual_apartment_num: null,
      actual_district_id: null,
    });
  }, []);

  const onSave = useCallback(async () => {
    if (token && clientType) {
      const bodyData = {
        ...data,
        ...actualData,
        actual,
        registration,
      };

      const { success, message } = await reqClientAddress(token, clientType, id, 'PUT', bodyData);
      dispatch(
        setModalInfo({
          open: true,
          success,
          message,
        })
      );
    }
  }, [token, data, actualData, actual, registration, id, dispatch]);

  const onRegionChange = useCallback((value) => {
    setData({ ...data, region_id: value, district_id: null, city_id: null });
  }, [data]);

  const onActualRegionChange = useCallback((value) => {
    setActualData({
      ...actualData,
      actual_region_id: value,
      actual_district_id: null,
      actual_city_id: null,
    });
  }, [actualData]);

  const onDistrictChange = useCallback((value) => {
    setData({ ...data, district_id: value, city_id: null });
  }, [data]);

  const onActualDistrictChange = useCallback((value) => {
    setActualData({ ...actualData, actual_district_id: value, actual_city_id: null });
  }, [actualData]);

  useEffect(() => {
    setRegions(initialData?.regions || []);
    setActualRegions(initialData?.regions || []);
    setAddressType(initialData?.address_type || []);
    setBuildingType(initialData?.building_type || []);
    setBuildingPartType(initialData?.building_part || []);
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
      building_part_id: initialData?.building_part_id || null,
      building_part_num: initialData?.building_part_num || null,
      apartment_type_id: initialData?.apartment_type_id || null,
      apartment_num: initialData?.apartment_num || null,
      district_id: initialData?.district_id || null,
    });
    setActualData({
      actual_region_id: initialData?.actual_region_id || null,
      actual_city_id: initialData?.actual_city_id || null,
      actual_address_type_id: initialData?.actual_address_type_id || null,
      actual_address: initialData?.actual_address || null,
      actual_building_type_id: initialData?.actual_building_type_id || null,
      actual_building_num: initialData?.actual_building_num || null,
      actual_building_part_id: initialData?.actual_building_part_id || null,
      actual_building_part_num: initialData?.actual_building_part_num || null,
      actual_apartment_type_id: initialData?.actual_apartment_type_id || null,
      actual_apartment_num: initialData?.actual_apartment_num || null,
      actual_district_id: initialData?.actual_district_id || null,
    });
  }, [initialData]);

  // Change district and city when changed region
  useEffect(() => {
    if (showModal) return;
    // get DISTRICTS
    (async () => {
      if (token && data.region_id) {
        const res = await reqClientDistricts(token, data.region_id);

        if (res.success) {
          setDistricts(res.data);
        }
      }
    })();

    // get CITIES
    (async () => {
      if (token && data.region_id) {
        const res = await reqClientCities(token, data.region_id, data.district_id);

        if (res.success) {
          setCities(res.data);
        }
      }
    })();
  }, [token, data.region_id, data.district_id, showModal]);

  // Change actual district and city when changed actual region
  useEffect(() => {
    if (showModal) return;

    // get DISTRICTS
    (async () => {
      if (token && actualData.actual_region_id) {
        const res = await reqClientDistricts(token, actualData.actual_region_id);

        if (res.success) {
          setActualDistricts(res.data);
        }
      }
    })();

    // get CITIES
    (async () => {
      if (token && actualData.actual_region_id) {
        const res = await reqClientCities(
          token, actualData.actual_region_id, actualData.actual_district_id
        );

        if (res.success) {
          setActualCities(res.data);
        }
      }
    })();
  }, [token, actualData.actual_region_id, actualData.actual_district_id, showModal]);

  return {
    regions,
    actualRegions,
    cities,
    actualCities,
    districts,
    actualDistricts,
    addressType,
    buildingType,
    buildingPartType,
    apartmentType,
    data,
    actualData,
    showModal,
    registration,
    actual,
    setShowModal,
    setData,
    setActualData,
    onRegionChange,
    onActualRegionChange,
    onDistrictChange,
    onActualDistrictChange,
    onClear,
    onSave,
    setRegistration,
    setActual,
  };
};
