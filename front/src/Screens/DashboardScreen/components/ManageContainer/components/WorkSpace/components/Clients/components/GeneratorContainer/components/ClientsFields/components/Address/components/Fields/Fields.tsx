import * as React from 'react';
import AddFormButton from '../../../../../../../../../../../../../../../../components/AddFormButton';
import CustomInput from '../../../../../../../../../../../../../../../../components/CustomInput';
import CustomSelect from '../../../../../../../../../../../../../../../../components/CustomSelect';
import { SelectItem } from '../../../../../../../../../../../../../../../../types';

type Props = {
  regions: SelectItem[],
  cities: SelectItem[],
  addressType: SelectItem[],
  apartmentType: SelectItem[],
  buildingType: SelectItem[],
  data: any,
  setData: (data: any) => void,
  setShowModal: (val: boolean) => void,
  actual?: boolean,
}

const Fields = ({
  regions,
  cities,
  addressType,
  buildingType,
  apartmentType,
  data,
  actual,
  setData,
  setShowModal
}: Props) => (
  <div className="address__container">
    <div className="clients__address-container">
      <CustomSelect
        label="Область"
        data={regions}
        onChange={(e) => setData({ ...data, [`${actual ? 'actual_region_id' : 'region_id'}`]: e })}
        selectedValue={actual ? data.actual_region_id : data.region_id}
      />
    </div>

    <div className="clients__address-container df">
      <CustomSelect
        label="Населений пункт"
        data={cities}
        onChange={(e) => setData({ ...data, [`${actual ? 'actual_city_id' : 'city_id'}`]: e })}
        selectedValue={actual ? data.actual_city_id : data.city_id}
      />
      <div className="add-button">
        <AddFormButton onClick={() => setShowModal(true)} />
      </div>
    </div>

    <div className="clients__address-container df duet">
      <div className="short-width">
        <CustomSelect
          label="Тип вулиці"
          data={addressType}
          onChange={(e) => setData({ ...data, [`${actual ? 'actual_address_type_id' : 'address_type_id'}`]: e })}
          selectedValue={actual ? data.actual_address_type_id : data.address_type_id}
        />
      </div>
      <div className="long-width">
        <CustomInput
          label="Назва вулиці"
          onChange={(e) => setData({ ...data, [`${actual ? 'actual_address' : 'address'}`]: e })}
          value={actual ? data.actual_address : data.address}
        />
      </div>
    </div>

    <div className="clients__address-container df duet">
      <div className="long-width">
        <CustomSelect
          label="Тип будинку"
          data={buildingType}
          onChange={(e) => setData({ ...data, [`${actual ? 'actual_building_type_id' : 'building_type_id'}`]: e })}
          selectedValue={actual ? data.actual_building_type_id : data.building_type_id}
        />
      </div>
      <div className="short-width">
        <CustomInput
          label="Номер будинку"
          onChange={(e) => setData({ ...data, [`${actual ? 'actual_building_num' : 'building_num'}`]: e })}
          value={actual ? data.actual_building_num : data.building_num}
        />
      </div>
    </div>

    <div className="clients__address-container df duet">
      <div className="long-width">
        <CustomSelect
          label="Тип приміщення"
          data={apartmentType}
          onChange={(e) => setData({ ...data, [`${actual ? 'actual_apartment_type_id' : 'apartment_type_id'}`]: e })}
          selectedValue={actual ? data.actual_apartment_type_id : data.apartment_type_id}
        />
      </div>
      <div className="short-width">
        <CustomInput
          label="Номер приміщення"
          onChange={(e) => setData({ ...data, [`${actual ? 'actual_apartment_num' : 'apartment_num'}`]: e })}
          value={actual ? data.actual_apartment_num : data.apartment_num}
        />
      </div>
    </div>
  </div>
);

export default Fields;
