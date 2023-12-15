CREATE OR REPLACE TRIGGER master_of_deps
  FOR update or insert ON employees
    COMPOUND TRIGGER

maxang number:=30;
type aloc_dep is record(nrang number, checkinfo number(1));
type lista_dep is table of aloc_dep index by pls_integer;
depdata lista_dep;
crt number;

  BEFORE STATEMENT IS
  BEGIN
     dep_info.depdata.delete;
 for linie in (select department_id, count(employee_id) nr 
                from employees right join departments using(department_id)
                where department_id is not null
                group by department_id) loop
  dep_info.depdata(linie.department_id).nrang:=linie.nr;
  dep_info.depdata(linie.department_id).checkinfo:=0;
 end loop;
  END BEFORE STATEMENT;

  BEFORE EACH ROW IS
  BEGIN
     if :new.department_id is not null then
  dep_info.depdata(:new.department_id).checkinfo:=1;
  dep_info.depdata(:new.department_id).nrang:=dep_info.depdata(:new.department_id).nrang+1;

  if dep_info.depdata(:new.department_id).nrang>dep_info.maxang and inserting then
   dep_info.depdata.delete;
   raise_application_error(-20567,'Prea multi angajati in dep '||:new.department_id||' la insert');
  end if;
end if;
  if updating and :old.department_id is not null then
    dep_info.depdata(:old.department_id).nrang:=dep_info.depdata(:old.department_id).nrang-1;
    dep_info.depdata(:old.department_id).checkinfo:=1;
  end if;
  END BEFORE EACH ROW;

  AFTER STATEMENT IS
  BEGIN
     crt:=dep_info.depdata.first();
 for i in 1..dep_info.depdata.count loop
   if dep_info.depdata(crt).nrang>dep_info.maxang and dep_info.depdata(crt).checkinfo=1 then
     dep_info.depdata.delete;
     raise_application_error(-20345,'Prea multi angajati in dep '||crt||' la update');
   end if;
   crt:=dep_info.depdata.next(crt);
 end loop;
  dep_info.depdata.delete;
  END AFTER STATEMENT;

END master_of_deps;
/