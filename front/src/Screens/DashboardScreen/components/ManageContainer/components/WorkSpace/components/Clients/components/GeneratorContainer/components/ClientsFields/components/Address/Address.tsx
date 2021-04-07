import React, { useState } from 'react';
import AddFormButton from '../../../../../../../../../../../../../../components/AddFormButton';
import CustomInput from '../../../../../../../../../../../../../../components/CustomInput';
import CustomSelect from '../../../../../../../../../../../../../../components/CustomSelect';
import PrimaryButton from '../../../../../../../../../../../../../../components/PrimaryButton';
import SectionWithTitle from '../../../../../../../../../../../../../../components/SectionWithTitle';
import AddCityModal from './AddCityModal';
import { useAddress, Props } from './useAddress';

const Address = (props: Props) => {
  const meta = useAddress(props);

  return (
    <div className="clients__address">
      <SectionWithTitle title="Адреса" onClear={meta.onClear}>
        <div className="clients__address-container">
          <CustomSelect
            label="Область"
            data={meta.regions}
            onChange={(e) => meta.setData({ ...meta.data, region_id: e })}
            selectedValue={meta.data.region_id}
          />
        </div>

        <div className="clients__address-container df">
          <CustomSelect
            label="Населений пункт"
            data={meta.cities}
            onChange={(e) => meta.setData({ ...meta.data, city_id: e })}
            selectedValue={meta.data.city_id}
          />
          <div className="add-button">
            <AddFormButton onClick={() => meta.setShowModal(true)} />
          </div>
        </div>

        <div className="clients__address-container df duet">
          <div className="short-width">
            <CustomSelect
              label="Тип вулиці"
              data={meta.addressType}
              onChange={(e) => meta.setData({ ...meta.data, address_type_id: e })}
              selectedValue={meta.data.address_type_id}
            />
          </div>
          <div className="long-width">
            <CustomInput
              label="Назва вулиці"
              onChange={(e) => meta.setData({ ...meta.data, address: e })}
              value={meta.data.address}
            />
          </div>
        </div>

        <div className="clients__address-container df duet">
          <div className="long-width">
            <CustomSelect
              label="Тип будинку"
              data={meta.buildingType}
              onChange={(e) => meta.setData({ ...meta.data, building_type_id: e })}
              selectedValue={meta.data.building_type_id}
            />
          </div>
          <div className="short-width">
            <CustomInput
              label="Номер будинку"
              onChange={(e) => meta.setData({ ...meta.data, building_num: e })}
              value={meta.data.building_num}
            />
          </div>
        </div>

        <div className="clients__address-container df duet">
          <div className="long-width">
            <CustomSelect
              label="Тип приміщення"
              data={meta.apartmentType}
              onChange={(e) => meta.setData({ ...meta.data, apartment_type_id: e })}
              selectedValue={meta.data.apartment_type_id}
            />
          </div>
          <div className="short-width">
            <CustomInput
              label="Номер приміщення"
              onChange={(e) => meta.setData({ ...meta.data, apartment_num: e })}
              value={meta.data.apartment_num}
            />
          </div>
        </div>
      </SectionWithTitle>

      <div className="middle-button">
        <PrimaryButton label="Зберегти" onClick={meta.onSave} disabled={false} />
      </div>

      <AddCityModal open={meta.showModal} onClose={meta.setShowModal} />
    </div>
  );
};

export default Address;
