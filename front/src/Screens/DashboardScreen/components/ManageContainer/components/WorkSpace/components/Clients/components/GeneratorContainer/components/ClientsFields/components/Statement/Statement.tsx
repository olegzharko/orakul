import * as React from 'react';
import CustomDatePicker from '../../../../../../../../../../../../../../components/CustomDatePicker';
import CustomInput from '../../../../../../../../../../../../../../components/CustomInput';
import CustomSelect from '../../../../../../../../../../../../../../components/CustomSelect';
import PrimaryButton from '../../../../../../../../../../../../../../components/PrimaryButton';
import SectionWithTitle from '../../../../../../../../../../../../../../components/SectionWithTitle';

const Statement = () => (
  <div className="clients__statement">
    <SectionWithTitle title="Заява-згода" onClear={() => console.log('clear')}>
      <div className="grid mb20">
        <CustomSelect label="Шаблон згоди" data={[]} onChange={(e) => console.log(e)} />
        <CustomSelect label="Тип шлюбного свідоцтва" data={[]} onChange={(e) => console.log(e)} />
        <CustomSelect label="Пункт згоди у договорі" data={[]} onChange={(e) => console.log(e)} />
        <CustomInput label="Серія свідоцтва" onChange={(e) => console.log(e)} />
        <CustomInput label="Номер свідоцтва" onChange={(e) => console.log(e)} />
        <CustomDatePicker label="Виданий" onSelect={(e) => console.log(e)} />
      </div>

      <div className="grid mb20">
        <CustomInput label="Орган, що видав" onChange={(e) => console.log(e)} />
        <CustomInput label="Реєстраційний номер свідоцтва" onChange={(e) => console.log(e)} />
      </div>

      <div className="grid mb20">
        <CustomSelect label="Нотаріус" data={[]} onChange={(e) => console.log(e)} />
        <CustomDatePicker label="Дата підписання заяви-згоди" onSelect={(e) => console.log(e)} />
        <CustomInput label="Номер реєстрації у нотаріуса" onChange={(e) => console.log(e)} />
      </div>
    </SectionWithTitle>

    <div className="middle-button">
      <PrimaryButton label="Зберегти" onClick={() => console.log('click')} disabled={false} />
    </div>
  </div>
);

export default Statement;
