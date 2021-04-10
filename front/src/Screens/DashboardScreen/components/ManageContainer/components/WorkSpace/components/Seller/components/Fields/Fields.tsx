import * as React from 'react';
import CheckBanFields from '../../../../../../../../../../components/CheckBanFields';
import PrimaryButton from '../../../../../../../../../../components/PrimaryButton';
import SectionWithTitle from '../../../../../../../../../../components/SectionWithTitle';
import TitleInfoDuet from '../../../../../../../../../../components/TitleInfoDuet';
import { useFields } from './useFields';

const Fields = () => {
  const meta = useFields();

  return (
    <main className="seller">
      <SectionWithTitle title="Продавець">
        <div className="seller__info">
          <div className="seller__info-title" style={{ backgroundColor: meta.developer?.color }}>
            {meta.developer?.title}
          </div>
          <div className="grid">
            {meta.developer?.info.map(({ title, value }) => (
              <TitleInfoDuet title={title} info={value} />
            ))}
          </div>
        </div>
      </SectionWithTitle>

      <div className="seller__ban">
        <CheckBanFields data={meta.banData} setData={meta.setBanData} title="Заборони на продавця" />
        <PrimaryButton label="Зберегти" onClick={meta.onBanDataSave} disabled={meta.banDataSaveDisabled} className="seller__ban-button" />
      </div>

      <SectionWithTitle title="Подружжя">
        <div className="grid">
          <TitleInfoDuet title="Шаблон згоди" info="Іванов Іван Іванович" />
          <TitleInfoDuet title="Тип шлюбного свідоцтва" info="Іванов Іван Іванович" />
          <TitleInfoDuet title="Серія свідоцтва" info="Іванов Іван Іванович" />
          <TitleInfoDuet title="Номер свідоцтва" info="Іванов Іван Іванович" />
          <TitleInfoDuet title="Виданий" info="Орган, що видав" />
          <TitleInfoDuet title="Орган, що видав" info="Іванов Іван Іванович" />
          <TitleInfoDuet title="Реєстраційний номер свідоцтва" info="Іванов Іван Іванович" />
          <TitleInfoDuet title="Нотаріус" info="Іванов Іван Іванович" />
          <TitleInfoDuet title="Дата підписання заяви-згоди" info="Іванов Іван Іванович" />
          <TitleInfoDuet title="Номер реєстрації у нотаріуса" info="Іванов Іван Іванович" />
          <TitleInfoDuet title="Пункт згоди у договорі" info="Іванов Іван Іванович" />
        </div>
      </SectionWithTitle>
    </main>
  );
};

export default Fields;
